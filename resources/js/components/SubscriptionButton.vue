<template>
<div class="col-md-6">
		<button class="btn btn-danger" @click="toggleSubscription">
			{{owner ? '' : subscribed ? 'Unsubscribe' : 'Subscribe' }} {{count}} {{owner ? 'subsribers': ''}}
		</button>
	</div>
</template>


<script>
import numeral from 'numeral';

export default {
	props: {
		channel: {
			type: Object,
			required: true,
			default: {}
		},
		isubscriptions: {
			type: Array,
			required: true,
			default: () => []
		}
	},
	data: function() {
		return {
			subscriptions: this.isubscriptions
		};
	},
	computed: {
		subscribed() {
			if (!__auth()) return false;
			return !!this.subscriptions.find(
				subscription => subscription.user_id === __auth().id
			);
		},
		owner() {
			if (!__auth()) return false;
			return this.channel.user_id === __auth().id;
		},
		count() {
			return numeral(this.subscriptions.length).format('0a');
		},
		subscription() {
			if (!__auth()) return false;
			return this.subscriptions.find(
				subscription => subscription.user_id === __auth().id
			);
		}
	},
	methods: {
		async toggleSubscription() {
			if (!__auth()) {
				alert('Please Login!');
				return false;
			}
			if (this.owner) {
				alert('You can not subscribe for own channel!');
				return false;
			}
			if (this.subscribed) {
				try {
					const res = await axios.delete(
						`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`
					);
					this.subscriptions = this.subscriptions.filter(
						s => s.id !== this.subscription.id
					);
					console.log(res.data);
				} catch (error) {
					console.log(error.response);
				}
			} else {
				try {
					const res = await axios.post(
						`/channels/${this.channel.id}/subscriptions`
					);
					this.subscriptions = [...this.subscriptions, res.data];
					console.log(res.data);
				} catch (error) {
					console.log(error.response);
				}
			}
		}
	}
};
</script>
