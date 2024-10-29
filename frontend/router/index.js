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

		// pagename
		// {
		// 	path: "pagename",
		// 	component: () =>
		// 		import(
		// 			/* webpackChunkName: "training" */ "@modules/training/frontend/pages/pagename/index.vue"
		// 		),
		// 	children: [
		// 		{
		// 			path: "",
		// 			name: "training-pagename",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/pagename/crud/data.vue"
		// 				),
		// 		},

		// 		{
		// 			path: "create",
		// 			name: "training-pagename-create",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/pagename/crud/create.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/edit",
		// 			name: "training-pagename-edit",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/pagename/crud/edit.vue"
		// 				),
		// 		},

		// 		{
		// 			path: ":pagename/show",
		// 			name: "training-pagename-show",
		// 			component: () =>
		// 				import(
		// 					/* webpackChunkName: "training" */ "@modules/training/frontend/pages/pagename/crud/show.vue"
		// 				),
		// 		},
		// 	],
		// },
	],
};
