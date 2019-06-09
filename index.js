require('dotenv').config();
const { CommandoClient } = require('discord.js-commando');
const path = require('path');

const axios = require('axios'); // HTTP Client

const client = new CommandoClient({
  commandPrefix: '!',
  owner: process.env.BOT_OWNER,
  invite: 'https://discord.gg/pHnTma'
});

client.registry
  .registerDefaultTypes()
  .registerGroups([
    ['user', 'User related commands.'],
    ['fun', 'Fun!'],
    ['utilities', 'Utilities'],
    ['admin', 'Admin only commands!']
  ])
  .registerDefaultGroups()
  .registerDefaultCommands()
  .registerCommandsIn(path.join(__dirname, 'commands'));

client.once('ready', () => {
  console.log(`Logged in as ${client.user.tag}! (${client.user.id})`);
  client.user.setActivity('twice memes', { type: 'WATCHING' });
});

client.on('error', console.error);

client.login(process.env.BOT_TOKEN);

/// Logs Module

client.on('message', async message => {
  // message
  //   .react(client.emojis.get('586880576426999818'))
  //   .then(reaction => console.log(typeof reaction));

  if (message.author.bot == false) {
    //   const cos = message.send('ayyy');
    //   message.react('👍').then(() => message.react('👎'));
    //   const filter = (reaction, user) => {
    //     return (
    //       ['👍', '👎'].includes(reaction.emoji.name) &&
    //       user.id === message.author.id
    //     );
    //   };
    //   message
    //     .awaitReactions(filter, { max: 1, time: 60000, errors: ['time'] })
    //     .then(collected => {
    //       const reaction = collected.first();
    //       if (reaction.emoji.name === '👍') {
    //         message.reply('you reacted with a thumbs up.');
    //       } else {
    //         message.reply('you reacted with a thumbs down.');
    //       }
    //     })
    //     .catch(collected => {
    //       console.log(`After a minute, only ${collected.size} out of 4 reacted.`);
    //       message.reply(
    //         'you reacted with neither a thumbs up, nor a thumbs down.'
    //       );
    //     });
  }
  if (message.guild === null) return;
  axios
    .post(process.env.BACKEND_HOST + `api/v1/user/check`, {
      discord_id: message.author.id,
      name: message.author.username,
      nickname: message.member.nickname,
      guild_id: message.guild.id,
      guild_name: message.guild.name,
      channel_id: message.channel.id,
      channel_name: message.channel.name,
      content: message.content,
      bot: message.author.bot
    })
    .then(function(response) {
      if (response.data == 2) message.reply('User registered!');
    })
    .catch(function(error) {
      console.log(error);
    });
});
