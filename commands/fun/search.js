const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client
const bot_err = require('../../core/libraries/errors');

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
        const embed = new RichEmbed()
          .setColor(response.data.color)
          .setTitle(response.data.name)
          .setAuthor(message.author.username)
          .setDescription(
            `You found ${response.data.name} ! Its ${response.data.rarity}!`
          )
          .setThumbnail(response.data.image)

          .setTimestamp();

        msg.edit(embed);
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
