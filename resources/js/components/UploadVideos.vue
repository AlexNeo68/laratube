<script>
export default {
	props: {
		channel: {
			required: true,
			type: Object,
			default: () => ({})
		}
	},
	data() {
		return {
			selected: false,
			videos: [],
			progress: {},
			uploads: [],
			intervals: {}
		};
	},
	methods: {
		upload() {
			this.selected = true;

			this.videos = Array.from(this.$refs.videos.files);

			const uploaders = this.videos.map(video => {
				const form = new FormData();

				form.append('video', video);
				form.append('title', video.name);

				this.progress[video.name] = 0;

				return axios
					.post(`/channels/${this.channel.id}/videos`, form, {
						onUploadProgress: event => {
							this.progress[video.name] = Math.ceil(
								(event.loaded / event.total) * 100
							);
							this.$forceUpdate();
						}
					})
					.then(({ data }) => {
						this.uploads = [...this.uploads, data];
					});
			});

			axios.all(uploaders).then(() => {
				this.videos = this.uploads;

				this.videos.forEach(video => {
					this.intervals[video.id] = setInterval(() => {
						axios.get(`/videos/${video.id}`).then(({ data }) => {
							if (data.percentage === 100) {
								clearInterval(this.intervals[video.id]);
							}

							this.videos = this.videos.map(v => {
								if (v.id === data.id) {
									return data;
								}

								return v;
							});
						});
					}, 3000);
				});
			});
		}
	}
};
</script>
