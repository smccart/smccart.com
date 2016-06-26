import Compiler from './compiler'
import Sass from 'sass.js'

class SassCompiler extends Compiler
{
    render(data) {
        Sass.compile(data, function (response) {
            return response.text
        })
    }
}

export default SassCompiler