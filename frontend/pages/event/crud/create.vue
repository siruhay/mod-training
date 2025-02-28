<template>
	<form-create with-helpdesk>
		<template
			v-slot:default="{
				combos: { subdistricts, villages },
				record,
				store,
			}"
		>
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-text-field
							label="Mulai"
							type="date"
							v-model="record.startdate"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-text-field
							label="Selesai"
							type="date"
							v-model="record.finishdate"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-select
							:items="['LKD', 'DESA']"
							label="Target"
							v-model="record.mode"
							hide-details
						></v-select>
					</v-col>

					<v-col cols="6">
						<v-combobox
							:items="subdistricts"
							:return-object="false"
							label="Kecamatan"
							v-model="record.subdistrict_id"
							hide-details
							@update:modelValue="
								updateSubdistrict($event, store)
							"
						></v-combobox>
					</v-col>

					<v-col cols="6">
						<v-combobox
							:items="villages"
							:return-object="false"
							label="Kelurahan/Desa"
							v-model="record.village_id"
							hide-details
						></v-combobox>
					</v-col>
				</v-row>
			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "training-event-create",

	methods: {
		updateSubdistrict: function (subdistrict, store) {
			this.$http(`training/api/subdistrict/${subdistrict}/villages`).then(
				(response) => {
					store.combos.villages = response;
				}
			);
		},
	},
};
</script>
