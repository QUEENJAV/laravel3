import axios from "axios";

export const groupService = {
  async getGroupes() {
    return axios.get('/liste');
  }
};