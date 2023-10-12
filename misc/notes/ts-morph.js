/* The documentation at https://ts-morph.com/setup/ is excellent
 * https://ts-ast-viewer.com/ is very helpful too. This is just short notes
 * from the documentation
 */

// Navigation
.getChild*
.getParent()
.getFirstChildBySyntaxKind()
.getClass('MyClass') .getClasses() .getInterfaces()
.getModules()
ts.forEachChild(node, child={}) / node.forEachChild( child=> { Node.isClassDeclaration(child) })
node.forEachDescendant((node,traversal)=>{ traversal.skip/up.stop() })

classDeclaration.findRefernecesAsNodes()
identifier.getDefinitions() // identifier.getDefinitionNodes()
Node.isClassDeclaration(node)
node.print();


// Manipulation
node.replaceWithText('...')
sourceFile.addStatements('...;...;') / sourceFile.inserStatements(3, '...;...;')
sourceFile.removeStatements([3, 5]) / sourceFile.removeStatement(3)

sourceFile.getEnum('MyEnum', {
 renameInComments: true,
 renameInStrings: true,
}).rename('NewEnum')  // will also replace usages
node.remove();

node.set(manipulateJson(node.getStructure()))
sourceFile.addClass({name:'Name', ...someClass.getStructure()})

Structure.isExported(structure)
forEachStructureChild(structure, child=>{ child.name = 'newName' })

node.setOrder(index)  // Move node
functionDeclaration.setBodyText(writer=> ) // https://github.com/dsherret/code-block-writer