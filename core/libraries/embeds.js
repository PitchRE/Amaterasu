const { RichEmbed } = require('discord.js'); // Common
//
//
//
//
//
//
//
//
//
//
//
//
//

function rarity_embed(response, message) {
  var color = '#d3d3d3';
  switch (response.data.rarity.toUpperCase()) {
    case 'COMMON':
      color = '#ffffff';
      break;
    case 'UNCOMMON'.toUpperCase():
      color = '#2fe20f';
      break;
    case 'RARE':
      color = '#0f39e0';
      break;
    case 'EPIC':
      color = '#8f12c9';
      break;
    case 'LEGENDARY':
      color = '#ffd700';
      break;
  }

  let embed = new RichEmbed()

    .setTitle('Loot')

    .setColor(color)
    .addField('Name', response.data.name, true)
    .addField('Rarity', response.data.rarity, true)
    .addField('In Inventory', response.data.count, true)
    .setThumbnail(process.env.BACKEND_HOST + response.data.image)
    .setFooter(message.author.username, message.author.avatarURL)
    .setTimestamp();

  return embed;
}

//
//
//
//
//
//
//
//
//

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

//
//
//
//
//
//
//

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

function give(response, owner, target) {
  switch (response.data.status) {
    case -1:
      var give_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription("This user doesn't have account in our system.")
        .setTimestamp();
      break;

    case -2:
      var give_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Transaction Fail')
        .setDescription("You don't have enought items to give.")
        .setTimestamp();
      break;
    case 1 || 2:
      var give_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Transaction Succes')
        .setDescription('Transaction was successful.')
        .addField(
          'Item',
          `**${response.data.ammount}**x ${response.data.item_name}`,
          true
        )
        .addField(
          'Counterparties',
          `**${owner.username}** ==> **${target.username}**`,
          true
        )
        .setTimestamp();
      break;
  }
  return give_embed;
}

function recipe(response) {
  switch (response.data.status) {
    case 1:
      var recipe_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Recipe Succes')
        .setDescription(`You succesfull make ${response.data.item_name}!`)
        .setTimestamp();
      break;
    case -1:
      var missing = '';
      response.data.missing.forEach(function(value) {
        missing += `**${value}** \n`;
      });

      var recipe_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipe Fail')
        .setDescription(
          "Sadly, You don't have all of the items required by recipe!"
        )
        .addField('Missing Items', missing, true)
        .setTimestamp();
      break;
    case -2:
      var recipe_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipe Fail')
        .setDescription('Sadly, There is no recipe with that name!')
        .setTimestamp();
      break;
  }
  return recipe_embed;
}

function recipesAvailable(response) {
  switch (response.data.status) {
    case -1:
      var recipes_embed = new RichEmbed()
        .setColor('#FF0000')
        .setAuthor('Recipes')
        .setDescription(
          `Sadly, You don't have enought items to make any of recipes`
        )
        .setTimestamp();
      break;
    case 1:
      var Available = '';
      response.data.canMake.forEach(function(value) {
        Available += `**${value}** \n`;
      });

      var recipes_embed = new RichEmbed()
        .setColor('#5cb85c')
        .setAuthor('Recipes')
        .setDescription('Hurrey! You can make some items from recipes!')
        .addField('Available recipes to make', Available, true)
        .setTimestamp();
      break;
  }
  return recipes_embed;
}

function recipesAll(response) {
  var recipes = '';
  response.data.recipes.forEach(function(value) {
    recipes += `**${value}** \n`;
  });

  switch (response.data.status) {
    case 1:
      var recipes_embed = new RichEmbed()
        .setColor('#8A2BE2')
        .setAuthor('Recipes')
        .setDescription(recipes)
        .setTimestamp();
      break;
  }
  return recipes_embed;
}

module.exports = {
  rarity_embed,
  sell,
  backpack,
  give,
  recipe,
  recipesAvailable,
  recipesAll
};
