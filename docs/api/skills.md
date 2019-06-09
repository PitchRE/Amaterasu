# Skills Related Endpoints

### Buy

`/api/v1/user/skill/buy`

- Type: **POST**

> Increases X Skill.

#### Params

- `discord_id`: Discord id. (unique).
- `skill`: Name of the skill to increase.

#### Response

Status: `-1`

> Not Enought Gold.

```json
{
  "status": -1
}
```

Status: `1`

> Succes. Skill increased

```json
{
  "status": 1,
  "level": 32,
  "price": 260,
  "name": "Luck"
}
```

Level: Current Level of X skill.
Price: Price of next level.
Name: Name of increased skill.

---

### Skills/All

`/api/v1/user/skills`

- Type: **POST**

> Data about user skills.

#### Params

- `discord_id`: Discord id. (unique).

#### Response

> Succes.

```json
{
  "status": 1,
  "luck": 32,
  "luck_price": 260,
  "luck_bolean": true,
  "balance": 288
}
```

`luck`: Level of luck skill.
`luck_price`: Current price of luck upgrade.
`luck_bolean`: If (user cash >= luck_price).
`balance`: Ammount of user cash.

### Chances

`/api/v1/user/chances`

- Type: **POST**

> Data about user chances for items.

#### Params

- `discord_id`: Discord id. (unique).

#### Response

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

#### Notes

> Rarity chance is float with two decimal places (10.00).
