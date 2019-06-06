# User Related Endpoints

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



#### Note

__`discord_id` equal to `target_discord_id` will be always rejected.__

> Currently its only usefull to check if user have cooldown or not.
