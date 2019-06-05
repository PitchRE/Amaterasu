const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client

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
          prompt: 'Which item you would want to sell? (full name or id)',
          type: 'string'
        },
        {
          key: 'ammount',
          prompt: 'How much you would want to sell?',
          type: 'integer'
        }
      ]
    });
  }
  run(message, { item, ammount }) {
    console.log(item, ammount);
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/item/sell`, {
        discord_id: message.author.id,
        item_name: item,
        ammount: ammount
      })
      .then(function(response) {
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
