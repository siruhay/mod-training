<template>
	<form-show with-helpdesk>
		<template v-slot:default="{ combos: { speakers }, record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="6">
						<v-text-field
							label="Tanggal"
							type="date"
							v-model="record.datemark"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="3">
						<v-text-field
							label="Mulai"
							type="time"
							v-model="record.starttime"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="3">
						<v-text-field
							label="Selesai"
							type="time"
							v-model="record.finishtime"
							hide-details
							readonly
						></v-text-field>
					</v-col>

					<v-col cols="12">
						<v-textarea
							label="Agenda"
							v-model="record.agenda"
							hide-details
							readonly
						></v-textarea>
					</v-col>

					<v-col cols="12">
						<v-select
							:items="speakers"
							label="Pembicara"
							v-model="record.speaker_id"
							hide-details
							readonly
						></v-select>
					</v-col>
				</v-row>
			</v-card-text>
		</template>

		<template v-slot:helpdesk></template>
	</form-show>
</template>

<script>
export default {
	name: "training-rundown-show",
};
</script>
