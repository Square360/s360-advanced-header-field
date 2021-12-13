import { RULE_FONT_FILES } from './fonts.config';
import { RULE_IMAGES } from './images.config';
import { RULE_JAVASCRIPT_FILES } from './javascript.config';
import { RULE_REACT } from './react.config';
import { RULE_STYLES } from './styles.config';

let rules: any[] = [];

rules.push(RULE_FONT_FILES);
rules.push(RULE_IMAGES);
rules.push(RULE_JAVASCRIPT_FILES);
rules.push(RULE_REACT);
rules.push(RULE_STYLES);

export { rules as WEBPACK_MODULE_RULES };
