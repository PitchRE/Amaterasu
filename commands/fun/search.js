const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const bot_err = require('../../core/libraries/errors');
const func = require('../../core/libraries/embeds');

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'search',
      aliases: ['s'],
      group: 'fun',
      memberName: 'search',
      description: 'Search for items!',
      throttling: {
        usages: 1,
        duration: 60
      }
    });
  }
  async run(message) {
    const msg = await message.reply('Rolling');

    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/random`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        console.log(func.embed(response, message));
        msg.edit(func.embed(response, message));
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
