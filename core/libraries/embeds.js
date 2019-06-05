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

function sell(message, response, item, ammount) {
  let cash = response.data.cash;
  let balance = response.data.balance;
  let ammountleft = response.data.ammount;

  switch (response.data.status) {
    case -1:
      var my_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription(`You don't have enought items. \n `)

        .addField(response.data.item, response.data.ammountleft, true)

        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;

    case -2:
      var my_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription('There is no item with that name.')

        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;

    case 1:
      var my_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription(`${response.data.ammount}x ${response.data.item}`)

        .addField('Balance', balance, true)
        .addField('Income', cash, true)
        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');

      break;
    case 3:
      var itemdata = '';
      for (var key in response.data.itemCollection) {
        itemdata += `[**${response.data.itemCollection[key]}**]  ${key} \n`;
      }

      var my_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription(itemdata)

        .addField('Balance', balance, true)
        .addField('Income', cash, true)
        .setTimestamp()
        .setFooter('Marketplace', 'https://i.imgur.com/wSTFkRM.png');
      break;
  }

  return my_embed;
}

function backpack(response, text) {
  var bp = new RichEmbed()
    .setColor('#8A2BE2')
    .setAuthor('Backpack')
    .setDescription(text)

    .setTimestamp()
    .setFooter(
      `Backpack | Total Value: ${response.data.value}`,
      'https://i.imgur.com/wSTFkRM.png'
    );
  return bp;
}

module.exports = { embed, sell, backpack };
