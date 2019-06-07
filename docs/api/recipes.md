# Recipes Related Endpoints.



### Make


`
/api/v1/user/recipe/make
`

- Type: **POST** 	

> Makes item from recipe.



#### Params 


- `discord_id`: Discord id. (unique).
- `item_name`: Name of recipe/item to make.

> Used in __make__ command.


#### Possible Responses

Status: `1`
> Returns `item_name`.

Status: `-1`
> Returns array of missing items to make recipe.



#### Example


> Using Axios.



```javascript

  run(message, { item }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/recipe/make`, {
        discord_id: message.author.id,
        item_name: item.toLowerCase()
      })
      .then(function(response) {
        message.reply(embeds.recipe(response));
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});
  }
};


```



### All



`
/api/v1/user/recipes/all
`

- Type: **POST** 	


> Returns all of existing recipes.



#### Params 

- None.



#### Possible Responses

Status: `1`

> Returns array of names of all recipes.






### Available


```
/api/v1/user/recipes/available
```


- Type: **POST** 	


> Returns array of recipes, which user can make. (have items to make)


#### Params 


- `discord_id`: Discord id. (unique).



#### Possible Responses

Status: `1`
> Returns array `canMake` of recipes which user can make.

Status: `-1`
> There is no recipes which user can make.



#### Example


> Using Axios and Rich Embeds.


##### Request

```javascript

 run(message, { type }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/recipes/${type}`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        switch (type == 'available') {
          case true:
            message.reply(embeds.recipesAvailable(response));
            break;
          case false:
            message.reply(embeds.recipesAll(response));
            break;
        }
        console.log(response.data);
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});
      ```


##### Embed



```javascript


function recipesAvailable(response) {
  switch (response.data.status) {
    case -1:
      var recipes_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipes')
        .setDescription(
          `Sadly, You don't have enought items to make any of recipes`
        )
        .setTimestamp();
      break;
    case 1:
      var Available = '';
      response.data.canMake.forEach(function(value) {
        Available += `**${value}** \n`;
      });

      var recipes_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Recipes')
        .setDescription('Hurrey! You can make some items from recipes!')
        .addField('Available recipes to make', Available, true)
        .setTimestamp();
      break;
  }
  return recipes_embed;
}
````