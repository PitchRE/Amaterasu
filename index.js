require('dotenv').config();
const { CommandoClient } = require('discord.js-commando');
const path = require('path');

const client = new CommandoClient({
  commandPrefix: '?',
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
