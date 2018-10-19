let ChatData = {
  getBase(dataType) {
    return $.get("json/current_chat_" + dataType + ".json");
  }
};
export default ChatData;
