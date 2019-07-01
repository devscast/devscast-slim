/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * show a preview before the upload
 */
export default class UploadViewer {
  /**
   * constructor
   * @param elems
   */
  constructor(elems = []) {
    this.elem = elems;
    this.IMAGE_MINETYPES = ['images/jpg', 'images/jpeg', 'images/png', 'images/gif'];
    this.AUDIO_MINETYPES = ['audio/mp3', 'audio/mwa', 'audio/ogg'];
  }

  run () {
    this.elems.forEach(elem => {
        elem.addEventerListener('change', e => {
          e.preventDefault();
          window.alert(e.target)
        })
      }
    )
  }
}
