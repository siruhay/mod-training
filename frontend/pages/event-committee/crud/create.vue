<template>
	<form-create with-helpdesk>
		<template v-slot:default="{ combos: { committees }, record }">
			<v-card-text>
				<v-row dense>
					<v-col cols="12">
						<v-combobox
							:items="committees"
							label="Name"
							v-model="record.name"
							hide-details
							@update:modelValue="mapDataCombo($event, record)"
						></v-combobox>
					</v-col>

					<v-col cols="8">
						<v-text-field
							label="NIK/NIP"
							v-model="record.slug"
							hide-details
						></v-text-field>
					</v-col>

					<v-col cols="4">
						<v-select
							:items="['MODERATOR', 'FELLOW', 'SPEAKER']"
							label="Tipe"
							v-model="record.type"
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
	name: "training-committee-create",

	methods: {
		mapDataCombo(model, record) {
			record.slug = model.value;
			record.type = model.type;
		},
	},
};
</script>
