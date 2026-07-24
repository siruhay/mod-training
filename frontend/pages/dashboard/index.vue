<template>
	<page-home page-name="training-dashboard">
		<template v-slot:default="{ record }">
			<v-row dense>
				<v-col md="3" cols="12">
					<widget-number
						color="teal"
						icon="school"
						label="Total Kegiatan Pelatihan"
						:value="`${record.totalEvents ?? 0}`"
					></widget-number>
				</v-col>

				<v-col md="3" cols="12">
					<widget-number
						color="orange"
						icon="event_upcoming"
						label="Kegiatan Akan Datang"
						:value="`${record.upcomingEvents ?? 0}`"
					></widget-number>
				</v-col>

				<v-col md="3" cols="12">
					<widget-number
						color="green"
						icon="task_alt"
						label="Kegiatan Selesai"
						:value="`${record.completedEvents ?? 0}`"
					></widget-number>
				</v-col>

				<v-col md="3" cols="12">
					<widget-number
						color="blue"
						icon="how_to_reg"
						label="Total Peserta Diterima"
						:value="`${record.acceptedParticipants ?? 0}`"
					></widget-number>
				</v-col>
			</v-row>
		</template>
	</page-home>
</template>

<script>
export default {
	name: "training-dashboard",
};
</script>
