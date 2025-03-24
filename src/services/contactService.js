import axios from "axios";

export const contactService = {
  async getContacts(searchQuery) {
    return axios.get(`/contacts?&searchQuery=` + searchQuery);
  },
  async getContact(id) {
    return axios.get(`/contacts/${id}`);
  },
  async updateContact(id, data) {
    return axios.put(`/contacts/${id}`, data);
  },
  async deleteContact(id) {
    return axios.delete(`/contacts/${id}`);
  },
  async toggleFavorite(id, state) {
    
    return axios.post(`/contacts/${id}/updateFavoriteStatus`, {is_favorite:!state});
  },
  async changePage(url) {
    return axios.get(url);
  }
};