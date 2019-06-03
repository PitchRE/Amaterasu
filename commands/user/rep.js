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
      }
    });
  }
  run(message) {
    // Check if user mentioned someone | Required

    if (
      !message.mentions.users.first() ||
      message.mentions.users.first().id == message.author.id
    ) {
      return message.reply('You need to @mention someone!');
    } else {
      var user = message.mentions.users.first();
    }

    /// HTTP Request to backend.

    // Possible Responses :

    // 2 = Succes
    // -1 = Cooldown not yet ready.

    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/rep`, {
        discord_id: user.id,
        name: user.username
      })
      .then(function(response) {
        if (response.data.status == 2) {
          message.reply(`I gave ${user.username} reputation point!`);
        } else if (response.data.status == -1) {
          message.reply(
            `You need wait atleast ${
              response.data.time
            } minutes more before you gonna be able to use that command again!`
          );
        } else
          return message.reply(`${bot_err.api} \n Reputation Module Exception`);
      })
      .catch(function(error) {
        message.reply(`${bot_err.api} \n Reputation Backend Module Exception`);
        console.log(error);
      });
  }
};
