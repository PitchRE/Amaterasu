const { Command } = require('discord.js-commando'); // Common
const { RichEmbed } = require('discord.js'); // Common
const axios = require('axios'); // HTTP Client

module.exports = class avatar extends Command {
  constructor(client) {
    super(client, {
      name: 'daily',
      group: 'user',
      memberName: 'daily',
      description: 'Daily cash for free!@!!!',
      throttling: {
        usages: 2,
        duration: 10
      }
    });
  }
  run(message) {
    axios
      .post(process.env.BACKEND_HOST + `api/v1/user/daily`, {
        discord_id: message.author.id
      })
      .then(function(response) {
        switch (response.data.status) {
          case -1:
            message.reply(
              `You need to wait atleast ${
                response.data.time
              } more before you gonna be able use that command again!`
            );
            break;
          case 1:
            message.reply(
              `Its your **${
                response.data.daily_train
              }** day in the row! \n + **${
                response.data.daily_cash
              }** to your account balance!`
            );
            break;
          case 2:
            message.reply(
              `Sadly, u lost yours daily train after **${
                response.data.daily_train
              }** days! \n + **${
                response.data.daily_cash
              }** to your account balance!`
            );
            break;
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
