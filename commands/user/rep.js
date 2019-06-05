const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const bot_err = require('../../core/libraries/errors');

const axios = require('axios'); // HTTP Client

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'rep',
      aliases: ['reputation'],
      group: 'utilities',
      memberName: 'rep',
      description: 'Gives someone else reputation point! Once per 12 hours!',
      throttling: {
        usages: 2,
        duration: 10
      },
      args: [
        {
          key: 'user',
          prompt:
            'Which user do you want to give reputation point? \n **Mention yourself if you want to check cooldowns!**',
          type: 'user'
        }
      ]
    });
  }
  run(message, { user }) {
    // Check if user mentioned someone | Required

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
  }
};
