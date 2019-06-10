# Recipe System

## Endpoints

### Make

`/api/v1/user/recipe/make`

- Type: **POST**

> Makes item from recipe.

> Used in make command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

- `item_name`: Name of recipe/item to make.

##### Possible Status Response

- `50`: Critical error, no such user.

`1` : Succes.

`-1` : Fail, not enought items..

`-2`: There is no recipe with that name.

##### Responses

```json
{
  "status": -1,
  "missing": ["Jelly", "The Story Begins"]
}
```

> `missing`: Array of missing items to make this recipe.

```json
{
  "status": 1,
  "item_name": "Candy"
}
```

> `item_name`: Name of just maked item.

<details>
<summary>Example usage</summary>

> Axios HTTP Library

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

> We can now generate embed response.

```javascript
function recipe(response) {
  switch (response.data.status) {
    case 1:
      var recipe_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Recipe Succes')
        .setDescription(`You succesfull make ${response.data.item_name}!`)
        .setTimestamp();
      break;
    case -1:
      var missing = '';
      response.data.missing.forEach(function(value) {
        missing += `**${value}** \n`;
      });

      var recipe_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipe Fail')
        .setDescription(
          "Sadly, You don't have all of the items required by recipe!"
        )
        .addField('Missing Items', missing, true)
        .setTimestamp();
      break;
    case -2:
      var recipe_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipe Fail')
        .setDescription('Sadly, There is no recipe with that name!')
        .setTimestamp();
      break;
  }
  return recipe_embed;
}
```

</details>

### All

`/api/v1/user/recipes/all`

- Type: **POST**

> Returns all of existing recipes.
> Used in **recipes** command.

##### Required Post Parameters

- None.

##### Possible Status Response

- `1` : Succes

##### Example Response

```json
{
  "status": 1,
  "recipes": ["Cookie Jar", "Candy"]
}
```

### Available

`/api/v1/user/recipes/available`

- Type: **POST**

> Returns array canMake of recipes which user can make.
> Used in **recipes** command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

- `50`: Critical error, no such user.
- `-1`: There is no recipes which user can make.
- `1` Succes, returns array canMake of recipes which user can make.

##### Example Responses

```json
{
  "status": 1,
  "canMake": ["Cookie Jar", "Candy"]
}
```

> Array of recipe names which user can make.

```json
{
  "status": -1
}
```

> There is no recipes which user can make.

<details>
<summary>Example usage</summary>

> Axios HTTP Library

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
  }
```

!> `type` is argument, can be **all** or **available**

> We can now generate embed response depending on our argument.

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
```

```javascript
function recipesAll(response) {
  var recipes = '';
  response.data.recipes.forEach(function(value) {
    recipes += `**${value}** \n`;
  });

  switch (response.data.status) {
    case 1:
      var recipes_embed = new RichEmbed()
        .setColor('#8A2BE2')
        .setAuthor('Recipes')
        .setDescription(recipes)
        .setTimestamp();
      break;
  }
  return recipes_embed;
}
```

</details>
