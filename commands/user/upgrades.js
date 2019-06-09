const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const bot_err = require('../../core/libraries/errors');
const embeds = require('../../core/libraries/embeds'); /// Embed response library

const axios = require('axios'); // HTTP Client

module.exports = class Upgrades extends Command {
  constructor(client) {
    super(client, {
      name: 'upgrade',
      aliases: ['up'],
      group: 'user',
      memberName: 'upgrades',
      description: 'Upgrade one of your skills!'
    });
  }
  async run(message) {
    const filter = (reaction, user) => {
      return (
        ['⭐', '2⃣', '3⃣', '❌'].includes(reaction.emoji.name) &&
        user.id === message.author.id
      );
    };

    var skill;

    axios
      .post(process.env.BACKEND_HOST + `/api/v1/user/skills`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        var exampleEmbed = new RichEmbed()
          .setColor('#0099ff')
          .setTitle('Upgrade Shop')
          .addField(
            `⭐ Luck **${response.data.luck}**`,
            `${response.data.luck_price} :moneybag:`
          )
          .setTimestamp()
          .setFooter(
            `${message.author.username} Balance: ${response.data.balance}`,
            message.author.avatarURL
          );

        message.say(exampleEmbed).then(async bot_msg => {
          if (response.data.luck_bolean == true) await bot_msg.react('⭐');
          await bot_msg.react('❌');

          bot_msg
            .awaitReactions(filter, { max: 1, time: 60000, errors: ['time'] })
            .then(collected => {
              const reaction = collected.first();

              switch (reaction.emoji.name) {
                case '⭐':
                  skill = 'Luck';
                  break;
                // case '2⃣':
                //   skill = 'Strenght';
                //   break;
                // case '3⃣':
                //   skill = 'Agility';
                //   break;
                case '❌':
                  return message.reply('Canceled.');
                  break;
              }
            })
            .then(collected => {
              bot_msg.delete();
              axios
                .post(process.env.BACKEND_HOST + `/api/v1/user/skill/buy`, {
                  discord_id: message.author.id,
                  skill_name: skill
                })
                .then(function(response) {
                  switch (response.data.status) {
                    case -1:
                      message.reply('Not enought gold');
                      break;
                    case 1:
                      message.reply(embeds.boutghtSkill(response, message));
                      break;
                  }
                })
                .catch(function(error) {
                  console.log(error);
                });
            })

            .catch(collected => {
              message.reply('You didnt choose any skill');
            });
        });
      })
      .catch(function(error) {
        message.reply(`${bot_err.api} \n Skills Backend Module Exception`);
        console.log(error);
      });
  }
};
