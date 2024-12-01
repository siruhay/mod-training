<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="8">
						<v-text-field
							label="NIK/NIP"
							v-model="record.slug"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-select
							:items="['CHAIRMAN', 'MEMBER', 'SPEAKER']"
							label="Tipe"
							v-model="record.type"
							hide-details
						></v-select>
					</v-col>

					<v-col cols="12">
						<v-text-field
							label="Name"
							v-model="record.name"
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
	name: "training-committee-create",
};
</script>
