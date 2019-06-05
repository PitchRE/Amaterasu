const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const embeds = require('../../core/libraries/embeds');

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'sell',
      group: 'fun',
      memberName: 'sell',
      description: 'Sell your item/items.',
      throttling: {
        usages: 2,
        duration: 10
      },
      args: [
        {
          key: 'item',
          prompt: 'Which item you would want to sell?  [Name of item or "all"]',
          type: 'string'
        },
        {
          key: 'ammount',
          prompt: 'How much you would want to sell?',
          type: 'string',
          validate: ammount => {
            if (
              ammount === '' + parseInt(ammount) ||
              ammount.toLowerCase() == 'all'
            ) {
              return true;
            } else {
              return 'Ammount of items must be integer or "all"';
            }
          }
        }
      ]
    });
  }
  run(message, { item, ammount }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/sell`, {
        discord_id: message.author.id,
        item_name: item.toLowerCase(),
        ammount: ammount.toLowerCase()
      })
      .then(function(response) {
        message.reply(embeds.sell(message, response, item, ammount));
      })
      .catch(function(error) {
        // handle error
        // console.log(error);
      })
      .finally(function() {
        // always executed
      });
  }
};
