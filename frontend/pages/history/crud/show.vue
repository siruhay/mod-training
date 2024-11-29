<template>
	<form-show
		hide-edit
		hide-delete
		with-helpdesk
	>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-row dense>
						<v-col cols="12">
							<v-text-field
								label="Name"
								v-model="record.name"
								hide-details
								readonly
							></v-text-field>
						</v-col>

						<v-col cols="6">
							<v-text-field
								label="Mulai"
								type="date"
								v-model="record.startdate"
								hide-details
								readonly
							></v-text-field>
						</v-col>

						<v-col cols="6">
							<v-text-field
								label="Selesai"
								type="date"
								v-model="record.finishdate"
								hide-details
								readonly
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<v-combobox
								:items="subdistricts"
								label="Kecamatan"
								v-model="record.subdistrict_id"
								hide-details
								readonly
							></v-combobox>
						</v-col>

						<v-col cols="12">
							<v-combobox
								:items="villages"
								label="Kelurahan/Desa"
								v-model="record.village_id"
								hide-details
								readonly
							></v-combobox>
						</v-col>
					</v-row>
				</v-row>
			</v-card-text>
		</template>

		<template v-slot:helpdesk></template>
	</form-show>
</template>

<script>
export default {
	name: "training-history-show",
};
</script>
