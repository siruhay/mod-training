<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-radio-group
							v-model="record.mode"
							hide-details
							inline
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
						<v-text-field
							label="Name"
							v-model="record.particiable_id"
							hide-details
						></v-text-field>
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

					<v-col cols="12">
						<v-text-field
							label="Kecamatan"
							v-model="record.subdistrict_id"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="12">
						<v-text-field
							label="Desa"
							v-model="record.village_id"
							hide-details
						></v-text-field>
					</v-col>
				</v-row>
			</v-card-text>
		</template>
	</form-edit>
</template>

<script>
export default {
	name: "training-participant-edit",
};
</script>
