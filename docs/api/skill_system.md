# Skill System

## Endpoints

### Buy

`/api/v1/user/skill/buy`

- Type: **POST**

> Increases X Skill.

> Used in **upgrades** command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).
- `skill`: Name of the skill to increase.

##### Possible Status Response

- `50`: Critical error, no such user.
- `-1` : Not Enought Gold.
- `1`: Succes. Skill increased

##### Example Responses

```json
{
  "status": 1,
  "level": 33,
  "price": 338,
  "name": "Luck"
}
```

- `name`: Name of increased skill.
- `price`: Price for next skill point.
- `level`: Current skill level.

```json
{
  "status": -1
}
```

<details>
<summary>Example usage</summary>

> Axios HTTP Library.
> Reaction Await/Collector.

!> This example uses addional endpoint.

```javascript

  async run(message) {
    const filter = (reaction, user) => {
      return (
        ['⭐', '❌'].includes(reaction.emoji.name) &&
        user.id === message.author.id
      );
    };

    var skill;

    axios
      .post(process.env.BACKEND_HOST + `/api/v1/user/skills`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        var exampleEmbed = new RichEmbed()
          .setColor('#0099ff')
          .setTitle('Upgrade Shop')
          .addField(
            `⭐ Luck **${response.data.luck}**`,
            `${response.data.luck_price} :moneybag:`
          )
          .setTimestamp()
          .setFooter(
            `${message.author.username} Balance: ${response.data.balance}`,
            message.author.avatarURL
          );

        message.say(exampleEmbed).then(async bot_msg => {
          if (response.data.luck_bolean == true) await bot_msg.react('⭐');
          await bot_msg.react('❌');

          bot_msg
            .awaitReactions(filter, { max: 1, time: 60000, errors: ['time'] })
            .then(collected => {
              const reaction = collected.first();

              switch (reaction.emoji.name) {
                case '⭐':
                  skill = 'Luck';
                  break;
                // case '2⃣':
                //   skill = 'Strenght';
                //   break;
                // case '3⃣':
                //   skill = 'Agility';
                //   break;
                case '❌':
                  return message.reply('Canceled.');
                  break;
              }
            })
            .then(collected => {
              bot_msg.delete();
              axios
                .post(process.env.BACKEND_HOST + `/api/v1/user/skill/buy`, {
                  discord_id: message.author.id,
                  skill_name: skill
                })
                .then(function(response) {
                  switch (response.data.status) {
                    case -1:
                      message.reply('Not enought gold');
                      break;
                    case 1:
                      message.reply(embeds.boutghtSkill(response, message));
                      break;
                  }
                })
                .catch(function(error) {
                  console.log(error);
                });
            })

            .catch(collected => {
              message.reply('You didnt choose any skill');
            });
        });
      })
      .catch(function(error) {
        message.reply(`${bot_err.api} \n Skills Backend Module Exception`);
        console.log(error);
      });
  }
```

> Addional Embeds used in this example.

```javascript
function boutghtSkill(response, message) {
  var skill_raised = new RichEmbed()
    .setAuthor('Skill Raised')
    .setDescription('Succesfully raised a skill.')
    .setColor('#FFD700')
    .addField(`Current ${response.data.name} Level`, response.data.level, true)
    .addField('Current Price', response.data.price, true)
    .setFooter(message.author.username, message.author.avatarURL)
    .setTimestamp();
  return skill_raised;
}
```

</details>

### Skills/All

`/api/v1/user/skills`

- Type: **POST**

> Returns data about user skills.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

- `50`: Critical error, no such user.
- `1`: Succes

##### Example Response

```json
{
  "status": 1,
  "luck": 32,
  "luck_price": 260,
  "luck_bolean": true,
  "balance": 288
}
```

- `luck`: Level of luck skill.
- `luck_price`: Current price of luck upgrade.
- `luck_bolean`: If (user cash >= luck_price).
- `balance`: Ammount of user cash.

> U can fins possible usage in [Buy Endpoint](api/skill_system?id=buy)
