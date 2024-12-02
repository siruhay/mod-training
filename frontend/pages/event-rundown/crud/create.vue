<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ combos: { speakers }, record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="6">
						<v-text-field
							label="Tanggal"
							type="date"
							v-model="record.datemark"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="3">
						<v-text-field
							label="Mulai"
							type="time"
							v-model="record.starttime"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="3">
						<v-text-field
							label="Selesai"
							type="time"
							v-model="record.finishtime"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="12">
						<v-textarea
							label="Agenda"
							v-model="record.agenda"
							hide-details
						></v-textarea>
					</v-col>

					<v-col cols="12">
						<v-select
							:items="speakers"
							label="Pembicara"
							v-model="record.speaker_id"
							hide-details
						></v-select>
					</v-col>
				</v-row>
			</v-card-text>
		</template>
	</form-create>
</template>

<script>
export default {
	name: "training-rundown-create",
};
</script>
