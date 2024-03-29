/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

import 'tw-elements';

import './styles/app.scss';
import './styles/sign.scss';

import { Select, initTE, Dropdown, Sidenav, Modal, Ripple, Alert, Toast  } from "tw-elements";
initTE({ Select, Dropdown, Sidenav, Modal, Ripple, Alert, Toast   });