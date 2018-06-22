<?php
	/*
	 * Copyright (C) 2018 Caspar Brenneisen
	 *
	 * This file is part of eCamp.
	 *
	 * eCamp is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU Affero General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * eCamp is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU Affero General Public License for more details.
	 *
	 * You should have received a copy of the GNU Affero General Public License
	 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
	 */

	return [
		'course_declaration' => [
			'title' => 'Kursanmeldung',
			'short' => 'Anmeldung an LKB (Picasso, Blockübersicht, Checklisten)',
			'date' => ($start - 8 * 7),
		],
		'dp' => [
			'title' => 'Detailprogramm einreichen',
			'short' => 'Definitives Detailprogramm an LKB.',
			'date' => ($start - 2 * 7),
		],
		'course_conclusion' => [
			'title' => 'Kursabschluss',
			'short' => 'TN-Liste, Kursbericht',
			'date' => ($ende + 3 * 7),
		],
		'course_material' => [
			'title' => 'J+S-Material/Landeskarten',
			'short' => 'J+S-Material und Landeskarten bestellen.',
			'date' => ($start - 6 * 7),
		],
	];
