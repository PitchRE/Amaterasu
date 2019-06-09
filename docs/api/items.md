# Items Related Endpoints

### Random

`/api/v1/user/item/random`

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

`/api/v1/user/items`

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
    }
  ],
  "value": 5500
}
```

- value: Calculated user items value.

### Sell

`/api/v1/user/item/sell`

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
> If `item_name` is rarity type, and `ammount` is integer, items with more or equaal to `ammount` are affected by.

#### Response

**If both, `item_name` and `ammount` are equal to "all"**

```json
{
  "status": 3,
  "cash": 15000,
  "balance": 264500,
  "ammount": 30,
  "itemCollection": "{\"Candy\":10,\"Twicecoaster\\uff1alane1\":10,\"Jelly\":10}"
}
```

- Status 3: all items solded.
- Cash: Income.
- Balance: Current balance.
- List of items solded + how much.

```json
{
  "status": 1,
  "cash": 500,
  "balance": 25000,
  "ammountleft": 1,
  "ammount": "1",
  "item": "Candy"
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
  "status": -1,
  "item": "Candy",
  "ammountleft": 1,
  "ammount": "50000"
}
```

- Status -1: Rejected. Not enought items.
- Cash: Income.
- Ammount: Number of items requested to sold.
- Ammountleft: How many items have been left
- item: Name of item requested to sell.

```json
{
  "status": -2,
  "item": "candysasasa"
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

### Give

`/api/v1/user/give`

- Type: **POST**

> Gives item from user A to user B

> Used in give command.

#### Params

- `discord_id`: Discord id. (owner of item) (unique).
- `target_discord_id` Discord ID (give item to this person).
- `item_name` Name of item to give.
- `ammount` Ammount of items to give.

#### Possible Responses

`-1` : No account. **Rejected**

`-2` : Not enought items/item not found. **Rejected**

`1` : User had this item before, succes.

`2` : User never had this item before, succes.

#### Example

```javascript
 run(message, { item, ammount, target }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/give`, {
        discord_id: message.author.id,
        target_discord_id: target.id,
        item_name: item.toLowerCase(),
        ammount: ammount
      })
      .then(function(response) {
        return message.reply(embeds.give(response, message.author, target));
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});

```
