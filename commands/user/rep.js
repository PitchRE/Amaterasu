const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common

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
    if (
      !message.mentions.users.first() ||
      message.mentions.users.first().id == message.author.id
    ) {
      return message.reply('You need to @menion someone!');
    } else {
      var user = message.mentions.users.first();
    }

    axios
      .get(process.env.BACKEND_HOST + `api/v1/user/${user.id}/rep`)
      .then(function(response) {})
      .catch(function(error) {
        console.log(error);
        message.reply(notifactions.api);
      })

      .finally(function() {});
  }
};
