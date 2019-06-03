const { Command } = require('discord.js-commando');
const { RichEmbed } = require('discord.js');

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'avatar',
      aliases: ['pfp'],
      group: 'utilities',
      memberName: 'avatar',
      description: 'Replies with a avatar. Optional args: @mention.'
    });
  }
  run(message) {
    if (!message.mentions.users.first()) {
      user = message.author;
    } else {
      var user = message.mentions.users.first();
    }

    const embed = new RichEmbed()
      .setAuthor(user.username + ' Avatar')
      .setImage(user.avatarURL)
      .setColor(0x00ae86)
      .setTimestamp();
    return message.embed(embed);
  }
};
