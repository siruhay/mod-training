<template>
	<form-show with-helpdesk>
		<template
			v-slot:default="{
				combos: { genders, subdistricts, villages, particiables },
				record,
			}"
		>
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-radio-group
							v-model="record.mode"
							hide-details
							inline
							readonly
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
							readonly
						></v-combobox>
					</v-col>

					<v-col cols="12">
						<v-combobox
							:items="villages"
							:return-object="false"
							label="Kelurahan/Desa"
							v-model="record.village_id"
							hide-details
							readonly
						></v-combobox>
					</v-col>

					<v-col cols="8">
						<v-combobox
							:items="particiables"
							label="Name"
							v-model="record.particiable"
							hide-details
							readonly
						></v-combobox>
					</v-col>

					<v-col cols="4">
						<v-select
							:items="genders"
							label="Gender"
							v-model="record.gender_id"
							hide-details
							readonly
						></v-select>
					</v-col>

					<v-col cols="6">
						<v-text-field
							label="NIK"
							v-model="record.nik"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="6">
						<v-text-field
							label="Handphone"
							v-model="record.phone"
							hide-details
							readonly
						></v-text-field>
					</v-col>
				</v-row>
			</v-card-text>
		</template>

		<template v-slot:helpdesk></template>
	</form-show>
</template>

<script>
export default {
	name: "training-participant-show",
};
</script>
