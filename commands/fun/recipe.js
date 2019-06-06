const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const embeds = require('../../core/libraries/embeds'); /// Embed response library

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'recipe',
      group: 'fun',
      memberName: 'recipe',
      description: 'Just recipe',
      throttling: {
        usages: 2,
        duration: 10
      },
      args: [
        {
          key: 'item',
          prompt: 'Recipe name? ',
          type: 'string'
        }
      ]
    });
  }
  run(message, { item }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/recipe/make`, {
        discord_id: message.author.id,
        item_name: item.toLowerCase()
      })
      .then(function(response) {
        message.reply(embeds.recipe(response));
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});
  }
};
