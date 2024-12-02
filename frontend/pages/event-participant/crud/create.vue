<template>
	<form-create with-helpdesk>
		<template
			v-slot:default="{
				combos: { subdistricts, villages, particiables },
				record,
				store,
			}"
		>
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-radio-group
							v-model="record.mode"
							hide-details
							inline
							@update:modelValue="
								updateMode($event, record, store)
							"
						>
							<v-radio
								label="LKD"
								value="LKD"
							></v-radio>

							<v-radio
								class="ml-4"
								label="Desa"
								value="Desa"
							></v-radio>
						</v-radio-group>
					</v-col>

					<v-col cols="12">
						<v-combobox
							:items="subdistricts"
							:return-object="false"
							label="Kecamatan"
							v-model="record.subdistrict_id"
							hide-details
							@update:modelValue="
								updateSubdistrict($event, record, store)
							"
						></v-combobox>
					</v-col>

					<v-col cols="12">
						<v-combobox
							:items="villages"
							:return-object="false"
							label="Kelurahan/Desa"
							v-model="record.village_id"
							hide-details
							@update:modelValue="
								updateVillage($event, record, store)
							"
						></v-combobox>
					</v-col>

					<v-col cols="8">
						<v-combobox
							:items="particiables"
							label="Name"
							v-model="record.particiable"
							hide-details
						></v-combobox>
					</v-col>

					<v-col cols="4">
						<v-select
							label="Gender"
							v-model="record.gender_id"
							hide-details
						></v-select>
					</v-col>

					<v-col cols="6">
						<v-text-field
							label="NIK"
							v-model="record.nik"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="6">
						<v-text-field
							label="Handphone"
							v-model="record.phone"
							hide-details
						></v-text-field>
					</v-col>
				</v-row>
			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "training-participant-create",

	methods: {
		updateMode: function (mode, record, store) {
			record.particiable = null;
			record.gender_id = null;
			record.nik = null;
			record.phone = null;

			this.updateVillage(record.village_id, record, store);
		},

		updateSubdistrict: function (subdistrict, record, store) {
			record.village_id = null;

			this.$http(`training/api/subdistrict/${subdistrict}/villages`).then(
				(response) => {
					store.combos.villages = response;
				}
			);
		},

		updateVillage: function (village, record, store) {
			this.$http(`training/api/village/${village}/particiables`, {
				params: {
					mode: record.mode,
				},
			}).then((response) => {
				store.combos.particiables = response;
			});
		},
	},
};
</script>
