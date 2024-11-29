export default {
	path: "/training",
	meta: { requiredAuth: true },
	component: () =>
		import(
			/* webpackChunkName: "training" */ "@modules/training/frontend/pages/Base.vue"
		),
	children: [
		{
			path: "",
			redirect: { name: "training-dashboard" },
		},

		{
			path: "dashboard",
			name: "training-dashboard",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/dashboard/index.vue"
				),
		},

		// event
		{
			path: "event",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-event",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-event-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event/crud/create.vue"
						),
				},

				{
					path: ":event/edit",
					name: "training-event-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event/crud/edit.vue"
						),
				},

				{
					path: ":event/show",
					name: "training-event-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event/crud/show.vue"
						),
				},
			],
		},

		// event/:event/committee
		{
			path: "event/:event/committee",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-committee/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-committee",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-committee/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-committee-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-committee/crud/create.vue"
						),
				},

				{
					path: ":committee/edit",
					name: "training-committee-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-committee/crud/edit.vue"
						),
				},

				{
					path: ":committee/show",
					name: "training-committee-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-committee/crud/show.vue"
						),
				},
			],
		},

		// event/:event/participant
		{
			path: "event/:event/participant",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-participant/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-participant",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-participant/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-participant-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-participant/crud/create.vue"
						),
				},

				{
					path: ":participant/edit",
					name: "training-participant-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-participant/crud/edit.vue"
						),
				},

				{
					path: ":participant/show",
					name: "training-participant-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-participant/crud/show.vue"
						),
				},
			],
		},

		// event/:event/postest
		{
			path: "event/:event/postest",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-postest/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-postest",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-postest/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-postest-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-postest/crud/create.vue"
						),
				},

				{
					path: ":postest/edit",
					name: "training-postest-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-postest/crud/edit.vue"
						),
				},

				{
					path: ":postest/show",
					name: "training-postest-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-postest/crud/show.vue"
						),
				},
			],
		},

		// event/:event/pretest
		{
			path: "event/:event/pretest",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-pretest/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-pretest",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-pretest/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-pretest-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-pretest/crud/create.vue"
						),
				},

				{
					path: ":pretest/edit",
					name: "training-pretest-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-pretest/crud/edit.vue"
						),
				},

				{
					path: ":pretest/show",
					name: "training-pretest-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-pretest/crud/show.vue"
						),
				},
			],
		},

		// event/:event/presence
		{
			path: "event/:event/presence",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-presence/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-presence",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-presence/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-presence-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-presence/crud/create.vue"
						),
				},

				{
					path: ":presence/edit",
					name: "training-presence-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-presence/crud/edit.vue"
						),
				},

				{
					path: ":presence/show",
					name: "training-presence-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-presence/crud/show.vue"
						),
				},
			],
		},

		// event/:event/rundown
		{
			path: "event/:event/rundown",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-rundown/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-rundown",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-rundown/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-rundown-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-rundown/crud/create.vue"
						),
				},

				{
					path: ":rundown/edit",
					name: "training-rundown-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-rundown/crud/edit.vue"
						),
				},

				{
					path: ":rundown/show",
					name: "training-rundown-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/event-rundown/crud/show.vue"
						),
				},
			],
		},

		// history
		{
			path: "history",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history/crud/create.vue"
						),
				},

				{
					path: ":history/edit",
					name: "training-history-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history/crud/edit.vue"
						),
				},

				{
					path: ":history/show",
					name: "training-history-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history/crud/show.vue"
						),
				},
			],
		},

		// history/:history/committee
		{
			path: "history/:history/committee",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-committee/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-committee",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-committee/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-committee-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-committee/crud/create.vue"
						),
				},

				{
					path: ":committee/edit",
					name: "training-history-committee-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-committee/crud/edit.vue"
						),
				},

				{
					path: ":committee/show",
					name: "training-history-committee-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-committee/crud/show.vue"
						),
				},
			],
		},

		// history/:history/participant
		{
			path: "history/:history/participant",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-participant/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-participant",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-participant/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-participant-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-participant/crud/create.vue"
						),
				},

				{
					path: ":participant/edit",
					name: "training-history-participant-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-participant/crud/edit.vue"
						),
				},

				{
					path: ":participant/show",
					name: "training-history-participant-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-participant/crud/show.vue"
						),
				},
			],
		},

		// history/:history/postest
		{
			path: "history/:history/postest",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-postest/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-postest",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-postest/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-postest-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-postest/crud/create.vue"
						),
				},

				{
					path: ":postest/edit",
					name: "training-history-postest-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-postest/crud/edit.vue"
						),
				},

				{
					path: ":postest/show",
					name: "training-history-postest-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-postest/crud/show.vue"
						),
				},
			],
		},

		// history/:history/pretest
		{
			path: "history/:history/pretest",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-pretest/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-pretest",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-pretest/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-pretest-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-pretest/crud/create.vue"
						),
				},

				{
					path: ":pretest/edit",
					name: "training-history-pretest-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-pretest/crud/edit.vue"
						),
				},

				{
					path: ":pretest/show",
					name: "training-history-pretest-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-pretest/crud/show.vue"
						),
				},
			],
		},

		// history/:history/presence
		{
			path: "history/:history/presence",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-presence/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-presence",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-presence/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-presence-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-presence/crud/create.vue"
						),
				},

				{
					path: ":presence/edit",
					name: "training-history-presence-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-presence/crud/edit.vue"
						),
				},

				{
					path: ":presence/show",
					name: "training-history-presence-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-presence/crud/show.vue"
						),
				},
			],
		},

		// history/:history/rundown
		{
			path: "history/:history/rundown",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-rundown/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-history-rundown",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-rundown/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-history-rundown-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-rundown/crud/create.vue"
						),
				},

				{
					path: ":rundown/edit",
					name: "training-history-rundown-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-rundown/crud/edit.vue"
						),
				},

				{
					path: ":rundown/show",
					name: "training-history-rundown-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/history-rundown/crud/show.vue"
						),
				},
			],
		},

		// report
		{
			path: "report",
			name: "training-report",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/report/index.vue"
				),
		},

		// subdistrict
		{
			path: "subdistrict",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-subdistrict",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-subdistrict-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict/crud/create.vue"
						),
				},

				{
					path: ":subdistrict/edit",
					name: "training-subdistrict-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict/crud/edit.vue"
						),
				},

				{
					path: ":subdistrict/show",
					name: "training-subdistrict-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict/crud/show.vue"
						),
				},
			],
		},

		// subdistrict/:subdistrict/village
		{
			path: "subdistrict/:subdistrict/village",
			component: () =>
				import(
					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict-village/index.vue"
				),
			children: [
				{
					path: "",
					name: "training-village",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict-village/crud/data.vue"
						),
				},

				{
					path: "create",
					name: "training-village-create",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict-village/crud/create.vue"
						),
				},

				{
					path: ":village/edit",
					name: "training-village-edit",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict-village/crud/edit.vue"
						),
				},

				{
					path: ":village/show",
					name: "training-village-show",
					component: () =>
						import(
							/* webpackChunkName: "training" */ "@modules/training/frontend/pages/subdistrict-village/crud/show.vue"
						),
				},
			],
		},
	],
};
