# Item System

## Rarity

Currently, items system supports 5 rarity types.

- Common
- Uncommon
- Rare
- Epic
- Legendary

<details>
<summary>Algorithm For Calculating Chances</summary>

> PHP

`
function chances(\$user)
{

    $common = 500;
    $uncommon = 250;
    $rare = 150;
    $epic = 80;
    $legendary = 20;

    $user_skill_level = $user->user_skills->luck;


    /**
     *
     * Above values will be loaded from database.
     * So you can change them for events etc.
     *
     *
     */

    for ($i = 0; $i < $user_skill_level; $i++) {


        if ($rare < 250) $rare += 1.2;
        if ($epic < 180) $epic += 0.7;
        if ($legendary < 140) $legendary += 0.3;
    }

    /**
     * Above part is for hardcoding limit.
     * We want to avoid situation where u can't no more draw common quality/rarity item.
     */


    $chance = array();


    for ($i = 0; $i < $common; $i++) {
        array_push($chance, "common");
    }

    for ($i = 0; $i < $uncommon; $i++) {
        array_push($chance, "uncommon");
    }

    for ($i = 0; $i < $rare; $i++) {
        array_push($chance, "rare");
    }

    for ($i = 0; $i < $epic; $i++) {
        array_push($chance, "epic");
    }

    for ($i = 0; $i < $legendary; $i++) {
        array_push($chance, "legendary");
    }

    $count = count($chance);

    $myObj = new stdClass();
    $myObj->common = number_format(($common / $count) * 100, 2);
    $myObj->uncommon = number_format(($uncommon / $count) * 100, 2);
    $myObj->rare = number_format(($rare / $count) * 100, 2);
    $myObj->epic = number_format(($epic / $count) * 100, 2);
    $myObj->legendary = number_format(($legendary / $count) * 100, 2);
    $myObj->luck = $user->user_skills->luck;

    return $myObj;

}
`

</details>

## Endpoints

### Random

`/api/v1/user/item/random`

- Type: **POST**

> Draws item.  
> Item rarity is weighted by luck skill.

> Used in **search** command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

- `-50`: Critical error, user doesn't exist.

- `1`: Succes

##### Response Example

```json
{
  "status": 1,
  "name": "Jelly",
  "rarity": "Common",
  "image": "🍓",
  "count": 1
}
```

- `name`: Name of the item.
- `rarity`: Rarity of the item.
- `image`: link to image.
- `count`: How many copies of this item user have.

### Backpack

`/api/v1/user/items`

- Type: **POST**

> Returns list of user items. Returns User items calculated value.  
> Returns list of user items with relations.

> Used in backpack command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

- `-50`: Critical error, user doesn't exist.

- `1`: Succes

##### Response Example

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

> `value`: Calculated user items value.

### Sell

`/api/v1/user/item/sell`

> Sells item.

> Used in sell command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).
- `item_name`: Name of item to sell or rarity (string).
- `ammount`: Number of items to sell. (int)

> `item_name` can be "all". In this case all user items are affected by this command.  
> `ammount` can be "all". In this case, all items with given name are sold.  
> `item_name` can be name of rarity type, in this case all items with given rarity are affected by.  
> If both, `item_name` and `ammount` are equal to "all", all user items are sold.  
> If `item_name` is "all" and `ammount` is integer, only items with count higher or equal to `ammount` are affected.  
> If `item_name` is rarity type, and `ammount` is integer, items with more or equaal to `ammount` are affected by.

##### Possible Status Response

- `-50`: Critical error, user doesn't exist.

- `-2`: There is no item with this name in user equipment.

- `-1`: Rejected. Not enought items.

- `1`: Item sold (single).

- `3`: All items solded.

##### Example Responses

> If `item_name` is equal to rarity or "all".

```json
{
  "status": 3,
  "cash": 1000,
  "balance": 3808,
  "ammount": 2,
  "itemCollection": {
    "Twicecoaster：lane1": "1",
    "PAGE TWO": "1"
  }
}
```

> If `item_name` is equal to name of item.

```json
{
  "status": 1,
  "cash": 500,
  "balance": 5808,
  "ammountleft": 1,
  "ammount": "1",
  "item": "Candy"
}
```

- `balance`: Current user balance.
- `cash`: Income after command usage.
- `ammount`: Ammount of items sold.
- `ammountleft`: Ammount of items left in user inventory (with that item name).
- `item`: Name of item solded.

> If `item_name` is rarity or "all".

```json
{
  "status": 3,
  "cash": 1000,
  "balance": 7308,
  "ammount": 2,
  "itemCollection": {
    "Candy": "1",
    "Jelly": "1"
  }
}
```

- `itemCollecton`: list of items solded + ammount.

<details>
<summary>Example usage</summary>

> Axios HTTP Library

```javascript
run(message, { item, ammount }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/sell`, {
        discord_id: message.author.id,
        item_name: item.toLowerCase(),
        ammount: ammount.toLowerCase()
      })
      .then(function(response) {
        message.reply(embeds.sell(message, response, item, ammount)); // To avoid trash lookking code, I excluded embed function.
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
function sell(message, response, item, ammount) {
  let cash = response.data.cash;
  let balance = response.data.balance;
  let ammountleft = response.data.ammount;

  switch (response.data.status) {
    case -1:
      var my_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription(`You don't have enought items. \n `)

        .addField(response.data.item, response.data.ammountleft, true)

        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;

    case -2:
      var my_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription('There is no item with that name.')

        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;

    case 1: //// If item was single.
      var my_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription(`${response.data.ammount}x ${response.data.item}`)
        .addField('Balance', balance, true)
        .addField('Income', cash, true)
        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');

      break;
    case 3: //// if item was rarity or "all"
      var itemdata = '';
      for (var key in response.data.itemCollection) {
        itemdata += `[**${response.data.itemCollection[key]}**]  ${key} \n`;
      }

      var my_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription(itemdata)

        .addField('Balance', balance, true)
        .addField('Income', cash, true)
        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;
  }

  return my_embed;
}
```

</details>

### Give

`/api/v1/user/give`

- Type: **POST**

> Gives item from user A to user B

> Used in give command.

##### Required Post Parameters

- `discord_id`: Discord id. (owner of item) (unique).
- `target_discord_id`: Discord ID (give item to this person).
- `item_name`: Name of item to give.
- `ammount`: Ammount of items to give.

##### Possible Status Response

`-50` : No account. Rejected

`-2` : Not enought items/item not found. Rejected

`1`: User had this item before, succes.

`2` : User never had this item before, succes.

##### Example Responses

```json
{
  "status": 2,
  "ammount": "1",
  "item_name": "Jelly"
}
```

- `ammount`: Ammount of items given.
- `item_name`: Name of given item.

<details>
<summary>Example usage</summary>

> Axios HTTP Library

```javascript
 run(message, { item, ammount, target }) {
    if (message.author == target) {
      return message.reply('You cannot give yourself a item.');
    }

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
  }
```

> We can now generate embed response.

```javascript
function give(response, owner, target) {
  switch (response.data.status) {
    case -1:
      var give_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription("This user doesn't have account in our system.")
        .setTimestamp();
      break;

    case -2:
      var give_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription("You don't have enought items to give.")
        .setTimestamp();
      break;
    case 1 || 2:
      var give_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription('Transaction was successful.')
        .addField(
          'Item',
          `**${response.data.ammount}**x ${response.data.item_name}`,
          true
        )
        .addField(
          'Counterparties',
          `**${owner.username}** ==> **${target.username}**`,
          true
        )
        .setTimestamp();
      break;
  }
  return give_embed;
}
```

</details>

### Chances

`/api/v1/user/chances`

- Type: **POST**

> Returns data about user chances for items.

> Used in **chances** command.

!> Chances are dependant of skills system. You can read more about it [here](/api/skill_system)

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

- `-50`: Critical error, user doesn't exist.

- `1`: Succes

##### Response Example

```json
{
  "common": "46.64",
  "uncommon": "23.32",
  "rare": "17.57",
  "epic": "9.55",
  "legendary": "2.76",
  "luck": 32
}
```

> Rarity chance is float with two decimal places (10.00).

<details>
<summary>Example usage</summary>

> Axios HTTP Library

```javascript

  async run(message) {
    var text = '';
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/chances`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        message.reply(embeds.chances(response, message));
      })
      .catch(function(error) {
        // handle error
        console.log(error);
      })
      .finally(function() {
        // always executed
      });
  }
```

> We can now generate embed response.

```javascript
function chances(response, message) {
  var chances = new RichEmbed()
    .setAuthor(`Chances | ${response.data.luck} Luck`)
    .setColor('#FFD700')
    .addField('Legendary', response.data.legendary)
    .addField('Epic', response.data.epic)
    .addField('Rare', response.data.rare)
    .addField('Uncommon', response.data.uncommon)
    .addField('Common', response.data.common)
    .setFooter(message.author.username, message.author.avatarURL)
    .setTimestamp();
  return chances;
}
```

</details>
