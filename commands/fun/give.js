const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const embeds = require('../../core/libraries/embeds'); /// Embed response library

module.exports = class Give extends Command {
  constructor(client) {
    super(client, {
      name: 'give',
      group: 'fun',
      memberName: 'give',
      description: 'Give your item/items.',
      throttling: {
        usages: 2,
        duration: 10
      },
      args: [
        {
          key: 'item',
          prompt: 'Which item you would want to give? ',
          type: 'string'
        },
        {
          key: 'ammount',
          prompt: 'How much items you would want to give?',
          type: 'integer',
          validate: ammount => {
            if (ammount > 0) {
              return true;
            } else {
              return 'Ammount of items must be higher than 0.';
            }
          }
        },
        {
          key: 'target',
          prompt: 'Who to give it to',
          type: 'user'
        }
      ]
    });
  }
  run(message, { item, ammount, target }) {
    if (message.author == target) {
      return message.reply('You cannot give yourself a item.');
    }

    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/give`, {
        discord_id: message.author.id,
        target_discord_id: target.id,
        item_name: item.toLowerCase(),
        ammount: ammount
      })
      .then(function(response) {
        return message.reply(embeds.give(response, message.author, target));
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});
  }
};
