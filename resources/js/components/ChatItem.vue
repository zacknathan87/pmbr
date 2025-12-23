<template>
  <div>
    <div class="chat-item system" v-if="this.type === 'system'">

      <div class="chat-bubble">
        <div class="chat-name">{{ $t('app.system_management') }}</div>
        <div class="chat-content">
           {{$t('app.current_game_id')}}: #{{ this.gameData.id }} ({{ this.gameDateTime }})
          <br />
          {{$t('app.new_game_message')}}
        </div>
      </div>
    </div>
    <div
      class="chat-item"
      :class="{ self: this.$auth.user().id === this.bet.user_id}"
      v-if="this.type === 'player'"
    >
      <div class="chat-avatar">
        <avatar :username="this.bet.user ? this.bet.user.username : this.bet.fake_username" :size="40" color="#fff"></avatar>
      </div>
      <div class="chat-bubble">
        <div class="chat-name">{{ this.bet.user ? this.bet.user.username : this.bet.fake_username }}</div>
        <div
          class="chat-content"
        >{{ $t('app.bet_on')}}: {{ $t('app.'+this.bet.bet_type.name_code) }} ( ${{ this.bet.amount }} )</div>
      </div>
    </div>
  </div>
</template>


<script>
import Avatar from "vue-avatar";
import moment from "moment";

export default {
  components: {
    Avatar
  },
  props: ["type", "bet", "game"],
  data() {
    return {
      icon: "fa-user",
      gameData: {},
      gameDateTime: ""
    };
  },
  mounted() {
    if (this.type === "system") {
      this.icon = "fa-headset";
    }

    if (this.game) {
      this.gameData = this.game;
      this.gameDateTime = moment(this.gameData.start_at).format(
        "DD-MM-YYYY hh:mm A"
      );
    }
  }
};
</script>

<style scoped>
.chat-item {
  padding: 15px 10px;
  display: flex;
}

.chat-avatar {
  margin-right: 10px;
}
.chat-name {
  color: #111;
  font-size: 12px;
  margin-bottom: 5px;
}
.chat-bubble {
  padding: 5px 15px 10px;
  background: #c2cee0;
  border-radius: 13px;
  width: 100%;
  max-width: 200px;
}

.chat-item.system .chat-bubble {
  max-width: 100%;
  background: #95de64;
}

.chat-item.system .chat-avatar .el-avatar--icon {
  background: #ff375e;
}

.chat-item.self {
  justify-content: flex-start;
  flex-direction: row-reverse;
}

.chat-item.self .chat-avatar {
  margin-right: 0;
  margin-left: 10px;
}

.chat-item.self .chat-bubble {
  background: #68c0ff;
}

.chat-content {
  line-height: 1.2;
  font-size: 13px;
}
</style>
