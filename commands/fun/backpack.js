const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const bot_err = require('../../core/libraries/errors');
const func = require('../../core/libraries/embeds');

const reactionControls = {
  NEXT_PAGE: '▶',
  PREV_PAGE: '◀',
  STOP: '⏹'
};

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'backpack',
      aliases: ['bp'],
      group: 'fun',
      memberName: 'backpack',
      description: 'Check your items!',
      throttling: {
        usages: 1,
        duration: 60
      }
    });
  }
  async run(message) {
    var text = '';
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/items`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        response.data.DATA.sort(function(a, b) {
          return b.count - a.count;
        });
        response.data.DATA.forEach(element => {
          text += ` \n [**${element.count}**] ${element.item_data.name} `;
        });

        message.reply('Check your DM!');
        message.author.send(text);
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