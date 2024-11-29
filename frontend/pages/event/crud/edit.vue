<template>
	<form-edit with-helpdesk>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-row dense>
						<v-col cols="12">
							<v-text-field
								label="Name"
								v-model="record.name"
								hide-details
							></v-text-field>
						</v-col>

						<v-col cols="6">
							<v-text-field
								label="Mulai"
								type="date"
								v-model="record.startdate"
								hide-details
							></v-text-field>
						</v-col>

						<v-col cols="6">
							<v-text-field
								label="Selesai"
								type="date"
								v-model="record.finishdate"
								hide-details
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<v-combobox
								:items="subdistricts"
								label="Kecamatan"
								v-model="record.subdistrict_id"
								hide-details
							></v-combobox>
						</v-col>

						<v-col cols="12">
							<v-combobox
								:items="villages"
								label="Kelurahan/Desa"
								v-model="record.village_id"
								hide-details
							></v-combobox>
						</v-col>
					</v-row>
				</v-row>
			</v-card-text>
		</template>
	</form-edit>
</template>

<script>
export default {
	name: "training-event-edit",
};
</script>
