const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const embeds = require('../../core/libraries/embeds'); /// Embed response library

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'recipes',
      group: 'fun',
      memberName: 'recipes',
      description: 'list recipes',
      throttling: {
        usages: 2,
        duration: 10
      },
      args: [
        {
          key: 'type',
          prompt: 'Which recipes you want to list? (**all** or **available**) ',
          type: 'string',
          validate: type => {
            if (type == 'all' || type == 'available') {
              return true;
            } else {
              return 'You need to choose between **all** or **available**';
            }
          }
        }
      ]
    });
  }
  run(message, { type }) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/recipes/${type}`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        switch (type == 'available') {
          case true:
            message.reply(embeds.recipesAvailable(response));
            break;
          case false:
            message.reply(embeds.recipesAll(response));
            break;
        }
        console.log(response.data);
      })
      .catch(function(error) {
        console.log(error);
      })
      .finally(function() {});
  }
};
