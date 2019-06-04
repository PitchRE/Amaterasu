const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'clear',
      aliases: ['c'],
      group: 'admin',
      memberName: 'clear',
      description: 'Clears chat!',
      userPermissions: ['MANAGE_MESSAGES'],
      throttling: {
        usages: 1,
        duration: 10
      },
      args: [
        {
          key: 'value',
          prompt: 'How much messages should I delete?',
          type: 'integer'
        }
      ]
    });
  }
  run(message, { value }) {
    if (value > 100)
      return message.reply('You cannot delete more than 100 messages at once!');
    message.channel.bulkDelete(value).then(() => {
      message.channel
        .send(`Deleted ${value} messages.`)
        .then(msg => msg.delete(5000));
    });
  }
};
