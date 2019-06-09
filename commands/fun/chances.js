const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const bot_err = require('../../core/libraries/errors');
const embeds = require('../../core/libraries/embeds');

const reactionControls = {
  NEXT_PAGE: '▶',
  PREV_PAGE: '◀',
  STOP: '⏹'
};

module.exports = class Chances extends Command {
  constructor(client) {
    super(client, {
      name: 'chances',
      group: 'fun',
      memberName: 'chances',
      description: 'Check chances for items.',
      throttling: {
        usages: 1,
        duration: 30
      }
    });
  }
  async run(message) {
    var text = '';
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/chances`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        message.reply(embeds.chances(response, message));
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
