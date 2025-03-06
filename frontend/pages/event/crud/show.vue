<template>
	<form-show with-helpdesk>
		<template
			v-slot:default="{ combos: { subdistricts, villages }, record }"
		>
			<div class="position-absolute" style="top: 0; right: 0">
				<v-chip class="mt-3 mr-4" color="blue" size="small">{{
					record.status
				}}</v-chip>
			</div>

			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-text-field
							label="Mulai"
							type="date"
							v-model="record.startdate"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-text-field
							label="Selesai"
							type="date"
							v-model="record.finishdate"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-select
							:items="['LKD', 'DESA']"
							label="Target"
							v-model="record.mode"
							hide-details
							readonly
						></v-select>
					</v-col>

					<v-col cols="6">
						<v-combobox
							:items="subdistricts"
							:return-object="false"
							label="Kecamatan"
							v-model="record.subdistrict_id"
							hide-details
							readonly
						></v-combobox>
					</v-col>

					<v-col cols="6">
						<v-combobox
							:items="villages"
							:return-object="false"
							label="Kelurahan/Desa"
							v-model="record.village_id"
							hide-details
							readonly
						></v-combobox>
					</v-col>
				</v-row>
			</v-card-text>
		</template>

		<template v-slot:info="{ record, theme }">
			<div class="text-overline mt-4">Aksi</div>
			<v-divider class="mb-3"></v-divider>

			<v-row dense>
				<v-col cols="4">
					<v-btn
						:color="theme"
						variant="flat"
						block
						@click="$router.push({ name: 'training-committee' })"
						>komite</v-btn
					>
				</v-col>

				<v-col cols="4">
					<v-btn
						:color="theme"
						variant="flat"
						block
						@click="$router.push({ name: 'training-participant' })"
						>Peserta</v-btn
					>
				</v-col>

				<v-col cols="4">
					<v-btn
						:color="theme"
						variant="flat"
						block
						@click="$router.push({ name: 'training-rundown' })"
						>rundown</v-btn
					>
				</v-col>

				<v-col cols="12" v-if="record.status === 'DRAFTED'">
					<v-btn
						:disabled="
							!(
								record.hasCommittee &&
								record.hasParticipant &&
								record.hasRundown
							)
						"
						color="deep-orange"
						variant="flat"
						block
						@click="postSubmission(record)"
						>KIRIM PERMOHONAN</v-btn
					>
				</v-col>

				<v-col cols="12" v-if="record.status === 'SUBMITTED'">
					<v-row dense>
						<v-col cols="6">
							<v-btn
								color="deep-orange"
								variant="flat"
								block
								@click="postRejected(record)"
								>TOLAK</v-btn
							>
						</v-col>

						<v-col cols="6">
							<v-btn
								color="green"
								variant="flat"
								block
								@click="postAssigned(record)"
								>SETUJUI</v-btn
							>
						</v-col>
					</v-row>
				</v-col>
			</v-row>
		</template>
	</form-show>
</template>

<script>
export default {
	name: "training-event-show",

	methods: {
		postSubmission: function (record) {
			this.$http(`training/api/event/${record.id}/submission`, {
				method: "POST",
				params: record,
			}).then(() => {
				this.$router.push({ name: "training-event" });
			});
		},
	},
};
</script>
