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
    ['utilities', 'Utilities']
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

client.on('message', async message => {
  axios
    .post(process.env.BACKEND_HOST + `api/v1/user/check`, {
      discord_id: message.author.id,
      name: message.author.username
    })
    .then(function(response) {
      if (response.data == 2) message.reply('User registered!');
    })
    .catch(function(error) {
      console.log(error);
    });
});
