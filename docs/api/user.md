> **Last Updated**: 10.06.2019

# User

User model represents user in discord server.

Each discord server member have his model.

User model should be created automatically.

User model consists from one table and three relation tables (as of 10.06.2019).

?> Users model.

**Default data**: token, discord_id, cash, xp, daily train dates.

- `discord_id`: foreign key, unique.
- `name`: Username.
- `cash` : Cash (currency).
- `daily_date`: Date when next daily command will be available.
- `daily_cash`: Ammount of cash for daily command.
- `daily_train`: How much days in the row was daily command used.
- `level`: User level.
- `xp`: User xp.
- `xp_needed`: Xp needed to next level.
- `message_count`: Count of user messages.

User foreign key is always equal to **discord_id**.

## Endpoints

User actions and related data is accesible via HTTP requests.

Usually, each response is in JSON and it has its own status code.

With status code you can distinguish responses.

Currently, most of the endpoints require `discord_id` as post parameter.

### Check

`/api/v1/user/check`

- Type: POST

> Checks if user exist in database.  
> If user doesn't exist in database, he is being registered.  
> If user exist in database, logs are trigered.

!> Its highly recommended to triger this endpoint on every user message.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).
- `name`: username.
- `nickname`: Nickname on the user guild.
- `guild_id`: Guild id.
- `guild_name`: Guild name.
- `channel_id`: Channel id.
- `channel_name`: Channel name.
- `content`: Content of message.

If any of these parameters will be uncorrect, request will be rejected.

##### Possible Status Response

`1` : Log created.

`2` : User registered.

`3`: Level up.

##### Responses

> If Status is equal to `3`, response contains addional data about current user level under `level` property.

```json
{
  "status": 1,
  "level": 5
}
```

<details>
<summary>Example usage</summary>

> Axios HTTP Library

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

</details>

### Reputation

`/api/v1/user/rep`

- Type: **POST**

> Checks how long ago, reputation point has been added.  
> If it was longer than predefined value (currently one hour), reputation point has been added.

> Used in **rep** command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).
- `target_discord`: Target Discord id (unique, which user should get reputation point)

##### Possible Status Response

`-50`: Critical error, no user found.

`2`: Reputation point approved.

`-1` Reputation action still have cooldown.

`3`: Reputation action have no cooldown but `target_discord_id` is equal to `discord_id`.

`4`: Reputation action still have cooldown. + `target_discord_id` is equal to `discord_id`.

!> `discord_id` equal to `target_discord_id` will be always rejected. In this case, its only usefull for checking user action cooldown.

#### Example Response

```json
{
  "status": 4,
  "points": 5,
  "time": 56
}
```

- `points`: Number of reputation points which `target_discord_id` have.
- `time`: Cooldown of reputation action in minutes.

If `time` is equal to -1, reputation point was just given.

<details>
<summary>Example usage</summary>

> Axios HTTP Library.  
> Snipet from **rep** command.

```javascript
  run(message, { user }) {

    /// HTTP Request to backend.

    // Possible Responses :

    // 2 = Succes
    // -1 = Cooldown not yet ready.
    // 3 = can rep.
    // 4 = cooldown not yet ready.

    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/rep`, {
        discord_id: message.author.id,
        target_discord_id: user.id,
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
  }
```

</details>

### Daily

`/api/v1/user/daily`

> Checks how long ago, daily command was used  
> If it was longer than one day, daily items are given to user.
> If it was longer than one day, daily train has been reseted, default items are given to the user.

> Used in **daily** command.

##### Required Post Parameters

- `discord_id`: Discord id. (unique).

##### Possible Status Response

`-50`: Critical error, no user found.

`-1`: Rejected, cooldown.

`1` Suces, daily train increased.

`2`: Succes, no cooldown, daily train has been reseted.

#### Example Response

> Succes, daily train increased.

```json
{
  "status": 1,
  "daily_cash": 720,
  "daily_train": 2
}
```

> Succes, train reset.

```json
{
  "status": 2,
  "daily_cash": 600,
  "daily_train": 0
}
```

> Rejected, Cooldown.

```json
{
  "status": -1,
  "time": "23 hours, 58 min"
}
```

> `daily_cash` : Ammount of given cash for daily command.  
> `daily_train` : How many days in the row, daily command is used by a user.  
> `time`: Cooldown.

<details>
<summary>Example usage</summary>

> Axios HTTP Library

```javascript
run(message) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/daily`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        switch (response.data.status) {
          case -1:
            message.reply(
              `You need to wait atleast ${
                response.data.time
              } more before you gonna be able use that command again!`
            );
            break;
          case 1:
            message.reply(
              `Its your **${
                response.data.daily_train
              }** day in the row! \n + **${
                response.data.daily_cash
              }** to your account balance!`
            );
            break;
          case 2:
            message.reply(
              `Sadly, u lost yours daily train after **${
                response.data.daily_train
              }** days! \n + **${
                response.data.daily_cash
              }** to your account balance!`
            );
            break;
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
```

</details>
