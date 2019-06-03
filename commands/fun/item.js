const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const bot_err = require('../../core/libraries/errors');

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'item',
      aliases: ['itm'],
      group: 'fun',
      memberName: 'item',
      description: 'random item',
      throttling: {
        usages: 1,
        duration: 60
      }
    });
  }
  run(message) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/random`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        message.reply(response.data.image);
        console.log(response.data);
      })
      .catch(function(error) {
        // handle error
        console.log(error);
      })
      .finally(function() {
        // always executed
      });
  }
};
