/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../sass/main.scss'
import './bootstrap'
import UploadViewer from "./UploadViewer";

const viewer = new UploadViewer('.js-upload-viewer');
viewer.run();
