const API_KEY = 'ae643e3d866548ca829938d1097fdee3';
const BASE_URL = 'https://newsapi.org/v2';

export default {
    async getTopNews(page = 1, category = '') {
        try {
            const params = new URLSearchParams({
                apiKey: API_KEY,
                language: 'en',
                pageSize: 12,
                page: page,
                sortBy: 'publishedAt'
            });

            if (category) {
                params.append('category', category);
            }

            const response = await fetch(`${BASE_URL}/top-headlines?${params.toString()}`);
            const data = await response.json();
            
            if (data.status !== 'ok') {
                throw new Error(data.message || 'Failed to fetch news');
            }
            
            return data;
        } catch (error) {
            console.error('Error fetching top news:', error);
            throw error;
        }
    },

    async searchNews(query, page = 1) {
        try {
            const params = new URLSearchParams({
                apiKey: API_KEY,
                q: query,
                language: 'en',
                pageSize: 12,
                page: page,
                sortBy: 'publishedAt'
            });

            const response = await fetch(`${BASE_URL}/everything?${params.toString()}`);
            const data = await response.json();
            
            if (data.status !== 'ok') {
                throw new Error(data.message || 'Failed to fetch news');
            }
            
            return data;
        } catch (error) {
            console.error('Error searching news:', error);
            throw error;
        }
    }
}