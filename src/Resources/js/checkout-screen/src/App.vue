<template>
    <div class="wrapper" id="app">
        <CardForm v-if="showContainer"
                  :form-data="formData"
                  @can-pay="pay"
                  v-bind:loading.sync="isLoading"
                  v-bind:disabled.sync="isLoading"
        />
    </div>
</template>

<script>
    import CardForm from '@/components/CardForm'
    import {PaymentService} from './services/paymentService'


    export default {
        name: 'app',
        components: {
            CardForm
        },
        data() {
            return {
                formData: {
                    cardName: '',
                    cardNumber: '',
                    cardMonth: '',
                    cardYear: '',
                    cardCvv: ''
                },
                isLoading: false,
                showContainer: false
            }
        },
        methods: {
            showAlert(isSuccess = false, title, message) {
                this.$alert(message, title, isSuccess ? "success" : "error", {
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                });
            },
            async pay(formData) {
                this.isLoading = true;
                const result = await PaymentService.subscribe({
                    card_holder_name: formData.cardName,
                    card_number: formData.cardNumberNotMask,
                    expire_month: parseInt(formData.cardMonth),
                    expire_year: parseInt(formData.cardYear),
                    cvc: parseInt(formData.cardCvv)
                });
                localStorage.clear();
                this.isLoading = false;
                this.showContainer = false;
                if (result.success === true) {
                    this.showAlert(true, this.$t("payment_success_title"), this.$t("payment_success_message"));
                } else {
                    this.showAlert(false, this.$t("security_breach_title"), result.message);
                }

            },
            cancelProcess() {
                this.showContainer = false;
                this.showAlert(false, this.$t('security_breach_title'), this.$t('security_breach_message'));
                localStorage.clear();
            },
            async auth() {
                const path = window.location.pathname;
                if (path === '/iyzico-laravel') {
                    const urlParams = new URLSearchParams(window.location.search);
                    const token = urlParams.get('token');
                    const plan_id = urlParams.get('plan_id');
                    const user_id = urlParams.get('user_id');

                    if (token === null || plan_id === null || user_id === null) {
                        this.cancelProcess();
                    } else {
                        localStorage.setItem('Appocean_token', token);
                        localStorage.setItem('Appocean_plan_id', plan_id);
                        localStorage.setItem('Appocean_user_id', plan_id);
                        const result = await PaymentService.me()
                        if (result === undefined || result.data.id !== parseInt(user_id)) {
                            this.cancelProcess();
                        } else {
                            this.showContainer = true;
                        }
                    }
                } else {
                    this.cancelProcess();
                }
            }
        },
        mounted() {
            this.$i18n.locale = 'tr'
            this.auth();
        }
    }
</script>

<style lang="scss">
    @import '../src/assets/style.scss';
</style>
