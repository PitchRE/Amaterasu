const { RichEmbed } = require('discord.js'); // Common

function embed(response, message) {
  ///
  ///
  ///

  var good = new RichEmbed()
    .setColor(response.data.color)
    .setTitle(response.data.name)
    .setAuthor(message.author.username)
    .setDescription(
      `You found ${response.data.name} ! Its ${response.data.rarity}!`
    )
    .setThumbnail(process.env.BACKEND_HOST + response.data.image)

    .setTimestamp();

  var nice = new RichEmbed()
    .setColor(response.data.color)
    .setTitle(response.data.name)
    .setAuthor(message.author.username)
    .setDescription(
      ` \n You found ${response.data.name} ${response.data.image} ! Its ${
        response.data.rarity
      }!`
    )

    .setTimestamp();

  switch (response.data.rarity) {
    case 'nice':
      return nice;
      break;
    case 'good':
      return good;
      break;
    case 'rare':
      break;
    case 'legendary':
      break;
  }
}

module.exports = { embed };
