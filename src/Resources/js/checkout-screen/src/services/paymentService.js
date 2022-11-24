import Vue from 'vue'

export class PaymentService {

    static async subscribe(parameters) {
        const token = localStorage.getItem('Appocean_token')
        const plan_id = localStorage.getItem('Appocean_plan_id')
        let url = this.getFullUrl("api/payments/plans/" + plan_id + "/subscriptions")
        const response = await Vue.axios.post(url, parameters, {
            headers: {
                Authorization: 'Bearer ' + token,
            }
        }).then(response => {
            return this.getResult(response.status === 201, "");
        }).catch(error => {
            return this.getResult(false, error.response.data.message);
        });
        return response;
    }

    static async me() {
        const token = localStorage.getItem('Appocean_token')
        let url = this.getFullUrl('api/me')
        const response = await Vue.axios.get(url, {
            headers: {
                Authorization: 'Bearer ' + token,
            }
        }).catch(error => {
            error.response.data.id = 0;
            return error.response.data;
        });
        return response.data;
    }

    static getFullUrl(routePath) {
        return "https://" + window.location.hostname + "/" + routePath;
    }

    static getResult(success, message) {
        return {
            success: success,
            message: message
        }
    }
}
