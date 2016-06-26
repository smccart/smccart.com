import Compiler from './compiler'
import Jade from 'jade'

class JadeCompiler extends Compiler
{
    render(data) {
        return Jade.compile(data)
    }
}

export default JadeCompiler