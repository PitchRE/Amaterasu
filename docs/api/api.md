## User





### Check


`
   /api/v1/user/check
`

- Type: **POST** 	

>Registers a user if doesn't exist.

>Logs message.

> Used in every user message.

#### Params


- `discord_id`: Discord id. (unique).
- `name`: username.
- `nickname`: Nickname on the user guild.
- `guild_id`: Guild id.
- `guild_name`: Guild name.
- `channel_id:` Channel id.
- `channel_name:` Channel name.
- `content`: Content of message.


#### Possible Responses


`1` : Log created.

`2` : User registered.





#### Example: 


> Using Axios


```javascript
client.on('message', async message => {
  if (message.guild === null) return;
  axios
    .post(process.env.BACKEND_HOST + 'api/v1/user/check', {
      discord_id: message.author.id,
      name: message.author.username,
      nickname: message.member.nickname,
      guild_id: message.guild.id,
      guild_name: message.guild.name,
      channel_id: message.channel.id,
      channel_name: message.channel.name,
      content: message.content,
      bot: message.author.bot
    })
    .then(function(response) {
      if (response.data == 2) message.reply('User registered!');
    })
    .catch(function(error) {
      console.log(error);
    });
});
```



### Reputation


`
/api/v1/user/rep
`


- Type: **POST** 

> Gives reputation point to `target_discord_id`.
> Cooldown is handled in backend.

> Used in reputation command.

#### Params


- `discord_id`: Discord id. (unique).
- `target_discord_id`: Discord id. (unique).


#### Possible Responses

>Status 2

```json
{
    "status": 2,
    "points": 3,
    "time": -1
}
```

Status 2: Reputation point approved.

Points: Number of reputation points which `target_discord_id` have.

Time -1: Reputation point just given. No cooldown data.



> Status -1

```json
{
    "status": -1,
    "points": 0,
    "time": 57
}
```
Status -1: There is cooldown.

Points: Number of reputation points which `target_discord_id` have.

Time 57: Cooldown left in minutes.


> Status 4

```json
{
    "status": 4,
    "points": 0,
    "time": 56
}
```

Status 4: There is cooldown + `discord_id` is equal to `target_discord_id`.

Points: Number of reputation points which `target_discord_id` have.

Time 56: Cooldown left in minutes.

__`discord_id` equal to `target_discord_id` will be always rejected.__


> Status 3

```json
{
    "status": 3,
    "points": 3,
    "time": -1
}
```
Status 3: There is no cooldown. Rejected.

Points: Number of reputation points which `target_discord_id` have.

Time -1: There is no cooldown.

__`discord_id` equal to `target_discord_id` will be always rejected.__



#### Example: 

> Using Axios

```javascript

 axios
      .post(process.env.BACKEND_HOST + 'api/v1/user/rep', {
        discord_id: message.author.id,
        target_discord_id: user.id,
        name: user.username
      })
      .then(function(response) {
        console.log(response.data.status);
        switch (response.data.status) {
          case 3:
            message.reply('U can already give someone rep!');

            break;
          case 4:
            message.reply(
              `You need wait atleast ${
                response.data.time
              } minutes more before you gonna be able to use that command again!`
            );
            break;
          case 2:
            message.reply(`I gave ${user.username} reputation point!`);

            break;

          case -1:
            message.reply(
              `You need wait atleast ${
                response.data.time
              } minutes more before you gonna be able to use that command again!`
            );
            break;
        }
      })
      .catch(function(error) {
        message.reply(`${bot_err.api} \n Reputation Backend Module Exception`);
        console.log(error);
      });
      ```

```


#### Note

__`discord_id` equal to `target_discord_id` will be always rejected.__

> Currently its only usefull to check if user have cooldown or not.




## Items


### Random


`
/api/v1/user/item/random
`

- Type: **POST** 	


> Draws item. 
> 
> Weighted RNG by user statistics.

> Used in search/s command.


#### Params


- `discord_id`: Discord id. (unique).






#### Response


```json
{
    "id": 1,
    "name": "Candy",
    "rarity": "nice",
    "value": 500,
    "image": "🍬",
    "color": "#3160ed",
    "created_at": null,
    "updated_at": null
}
```

### User items.


`
/api/v1/user/items
`

- Type: **POST** 	


> Returns list of user items.
> Returns User items calculated value.
> Returns list of user items with relations.

> Used in backpack command.



#### Params


- `discord_id`: Discord id. (unique).



#### Response


```json
{
    "DATA": [
        {
            "id": 1,
            "discord_id": 417726391698718720,
            "item_id": 6,
            "count": 3,
            "created_at": "2019-06-05 07:18:39",
            "updated_at": "2019-06-05 14:03:29",
            "item_data": {
                "id": 6,
                "name": "Twicecoaster：Lane 2",
                "rarity": "good",
                "value": 500,
                "image": "storage/TWICE/albums/TWICEcoaster_LANE_2.jpg",
                "color": "#3160ed",
                "created_at": null,
                "updated_at": null
            }
        },
        {
            "id": 2,
            "discord_id": 417726391698718720,
            "item_id": 1,
            "count": 2,
            "created_at": "2019-06-05 07:18:40",
            "updated_at": "2019-06-05 16:07:34",
            "item_data": {
                "id": 1,
                "name": "Candy",
                "rarity": "nice",
                "value": 500,
                "image": "🍬",
                "color": "#3160ed",
                "created_at": null,
                "updated_at": null
            }
        },
    ],
    "value": 5500
}
```

- value: Calculated user items value.



### Sell


`
/api/v1/user/item/sell
`


> Sells item.

> Used in sell command.

#### Params


- `discord_id`: Discord id. (unique).
- `item_name`: Name of item to sell or rarity (string)
- `ammount`: Number of items to sell. (int)



##### Note

> `item_name` can be "all". In this case all user items are affected by this command. 
>
> `ammount` can be "all". In this case, all items with given name are sold.
>
> `item_name` can be name of rarity type, in this case all items with given rarity are affected by.




> If both, `item_name` and `ammount` are equal to "all", all user items are sold.
> If `item_name` is "all" and `ammount` is integer, only items with count higher or equal to `ammount` are affected by.
> If  `item_name` is rarity type, and `ammount` is integer, items with  more or equaal to `ammount` are affected by.


#### Response


__If both, `item_name` and `ammount` are equal to "all"__

```json
{  
   "status":3,
   "cash":15000,
   "balance":264500,
   "ammount":30,
   "itemCollection":"{\"Candy\":10,\"Twicecoaster\\uff1alane1\":10,\"Jelly\":10}"
}
```

- Status 3: all items solded.
- Cash: Income.
- Balance: Current balance.
- List of items solded + how much. 


```json

{  
   "status":1,
   "cash":500,
   "balance":25000,
   "ammountleft":1,
   "ammount":"1",
   "item":"Candy"
}
```


- Status 1: Item sold (single).
- Cash: Income.
- Balance: Current balance.
- Ammount: Number of items solded.
- Ammountleft: How many items have been left
- item: Name of item solded.



```json

{  
   "status":-1,
   "item":"Candy",
   "ammountleft":1,
   "ammount":"50000"
}
```

- Status -1: Rejected. Not enought items.
- Cash: Income.
- Ammount: Number of items requested to sold.
- Ammountleft: How many items have been left
- item:  Name of item requested to sell.




```json

{  
   "status":-2,
   "item":"candysasasa"
}

```


- Status -2: There is no item with this name in user equipment.
- item: Name of item requested to sell.




#### Example

```javascript
  axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/sell`, {
        discord_id: message.author.id,
        item_name: item.toLowerCase(),
        ammount: ammount.toLowerCase()
      })
      .then(function(response) {
        message.reply(embeds.sell(message, response, item, ammount));
      })
      .catch(function(error) {
        // handle error
        // console.log(error);
      })
      .finally(function() {
        // always executed
      });
```